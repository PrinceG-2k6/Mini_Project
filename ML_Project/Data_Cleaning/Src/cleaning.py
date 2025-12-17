import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

  
def menu1():
    print("\n===== HANDLIING MISSING VALUE =====")
    print("1. Show All Missing Column")
    print("2. Show All Missing Row")
    print("3. Fill Missing Values")
    print("4. Drop Missing Values")
    print("5. Back")

def menu2():
    print("\n===== Filling MISSING VALUE =====")
    print("1. Forward Fill")
    print("2. Backward Fill")
    print("3. Replace NaN")
    print("4. Back")


def handle_missing(df):
    nan_columns_list = df.columns[df.isna().any()].tolist()
    nan_columns= df.columns[df.isna().any()]
    print("===============")
    print("There are Missing values in following columns : ")
    idx=1
    for i in nan_columns_list:
        print(idx,". ",i)
        idx=idx+1
    
    while True:
        
        pd.set_option('display.max_rows', None)
        menu1()
        choice = input("Enter choice: ")
        if choice == '1':
            print(df[nan_columns_list])
        elif choice == '2':
            print(df[df.isna().any(axis=1)])
        elif choice == '3':
            
            
            while True:
                menu2()
                ch = input("Enter choice: ")
                if ch=='1':
                    print("1. Row-Wise")
                    print("2. Column-Wise")
                    c = input("Enter choice: ")
                    
                    while True:
                        if c=='1':
                            df.ffill(inplace = True,axis=1)
                            print("Missing Values are filled by forward filling row wise !!")
                            break
                        elif c=='2':
                            df.ffill(inplace = True,axis=0)
                            print("Missing Values are filled by forward filling column wise !!")
                            break
                        else:
                            print("\n=================================")
                            print("Enter Choice Number Correctly!!")
                            print("=================================\n")


                elif ch=='2':
                    print("1. Row-Wise")
                    print("2. Column-Wise")
                    c = input("Enter choice: ")
                    while True:
                        if c=='1':
                            df.bfill(inplace = True,axis=1)
                            print("Missing Values are filled by forward filling row wise !!")
                            break
                        elif c=='2':
                            df.bfill(inplace = True,axis=0)
                            print("Missing Values are filled by forward filling column wise !!")
                            break
                        else:
                            print("\n=================================")
                            print("Enter Choice Number Correctly!!")
                            print("=================================\n")
                elif ch=='3':
                    print(1)
                elif ch=='4':
                    break
                else:
                    print("\n=================================")
                    print("Enter Choice Number Correctly!!")
                    print("=================================\n")
        elif choice == '4':
            break
        elif choice == '5':
            break
        else:
            print("\n=================================")
            print("Enter Choice Number Correctly!!")
            print("=================================\n")




    
def remove_duplicates(df):
    print(1)

def handle_outliers(df,col):
    print(1)